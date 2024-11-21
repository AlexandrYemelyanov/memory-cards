<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex" href="/">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="6" y="6" width="24" height="15" rx="2" ry="2" stroke="white" stroke-width="1.5"/>
                    <rect x="7" y="8" width="24" height="15" rx="2" ry="2" stroke="white" stroke-width="1.5"/>
                    <rect x="8" y="10" width="24" height="15" rx="2" ry="2" stroke="white" stroke-width="1.5"/>

                    <line x1="10" y1="12" x2="26" y2="12" stroke="white" stroke-width="1.5" />
                    <line x1="10" y1="16" x2="24" y2="16" stroke="white" stroke-width="1.5" />
                    <line x1="10" y1="20" x2="22" y2="20" stroke="white" stroke-width="1.5" />
                </svg>
                <span>Memory Cards</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a :class="{'nav-link': true, 'active': currentUrl == 'cards/add'}" href="/cards/add">
                            <i class="bi bi-plus-lg"></i>
                            {{ $trans.add }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a :class="{'nav-link': true, 'active': currentUrl == 'cards/import'}" href="/cards/import">
                            <i class="bi bi-database-up"></i>
                            {{ $trans.import }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a :class="{'nav-link': true, 'active': currentUrl == 'groups'}" href="/groups">
                            <i class="bi bi-collection"></i>
                            {{ $trans.groups }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a :class="{'nav-link': true, 'active': currentUrl == 'langs'}" href="/langs">
                            <i class="bi bi-translate"></i>
                            {{ $trans.langs }}
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">
                            {{ $trans.hi }}, {{ user.name }}
                        </a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link" href="/profile">
                            <i class="bi bi-person-circle"></i>
                            Профиль
                        </a>
                    </li-->
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            {{ $trans.logout }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span :class="'fi fi-' + currentLang"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item" href="?lang_ui=en">
                                    <span class="fi fi-gb"></span> English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="?lang_ui=ru">
                                    <span class="fi fi-ru"></span> Русский
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="?lang_ui=ua">
                                    <span class="fi fi-ua"></span> Українська
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="?lang_ui=cz">
                                    <span class="fi fi-cz"></span> Čeština
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: ['user', 'locale', 'currentUrl'],
    computed: {
        currentLang() {
            const localeFlag = {
                en: 'gb',
                ru: 'ru',
                ua: 'ua',
                cz: 'cz',
            };
            return localeFlag[ this.locale ];
        }
    },
};
</script>
