import axios from "axios";

export default {
    install(app) {
        app.config.globalProperties.$request = async (url, data = {}, method = 'get', config = {}) => {
            const message = {};
            let response = {};
            try {
                response = await axios[method](url, data, config);

                if (response.data && response.data.status && response.data.status === 200) {
                    message.success = response.data.message;
                } else {
                    message.error = response.data.message || 'Server error';
                }
            } catch (error) {
                message.error = error;
            }
            return {
                message: message,
                options: response.data ? response.data.options : {}
            };
        };
    }
}
