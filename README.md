### English
## About the App

The application helps expand your foreign vocabulary. It uses flashcards—foreign words and their translations are  
displayed on backgrounds of various colors. The colors make the information more engaging, capturing attention and  
creating memory "anchors". Different colors activate different parts of the brain, aiding in associating and  
differentiating  the information better.

The app allows you to study multiple languages simultaneously. For each language, you can create groups, such as "New", 
"Months", "Numbers" or "Learned", When adding words, you assign them to a pre-created group. You can also translate  
words both from the studied language to your native language and vice versa.

The main page of the app displays foreign words on a colorful background. Clicking on the background reveals the  
word's translation. Clicking again shows the next word in the selected group. On the same page, you can listen to  
the word's pronunciation, edit, or delete it.

Demo: https://mcards.fun/demo

## UI

### "Languages" Section
After registration, in the "Languages / Add Language" section, you need to add the languages you want to study.  
Then, select your native language in the "Languages / Your Native Language" section, and choose the language you want  
to study in "Languages / Studying". In the "Languages / Languages" section, you can modify or delete selected languages.

### "Groups" Section
Here, you need to select the language for which you are creating or editing groups.  
In the "Groups / Move" section, you can transfer flashcards from one group to another.

### "Import" Section
In this section, you can import a CSV file where the first column is the foreign word and the second column is its  
translation. Before importing, you need to select the group where the flashcards will be saved.

### "Add" Section
The first field is for entering the foreign word, and the second is for its translation. Each input field includes a   
translation button. When saving or importing, a color for the flashcard will be generated automatically.

### "Home" Section
This section displays flashcards. Choose the group of flashcards you want to study. Clicking the background will reveal  
the translation, and clicking again will show the next flashcard. Below the flashcards is a menu that allows you to  
listen to the foreign word's pronunciation, edit, or delete the card.

## Installation
The app uses the following stack: Laravel 11.30.0, PHP 8.3, MySQL 8.0, Vue 3, Nginx Alpine, Docker Compose, Bootstrap 5,  
TailWindCSS and Vite. To install the app, you must have  [Docker Desktop](https://www.docker.com/products/docker-desktop/),  
installed on your system and optionally, Git.

1. Clone this repository into the installation folder:
   ```bash
   git clone https://github.com/AlexandrYemelyanov/memory-cards.git
   ```
   Or download the archive and extract it into the installation folder if Git is not installed.
2. Change the directory:
   ```bash
   cd memory-cards/memory_cards/
   ```
3. Create the environment file:
   ```bash
   cp .env.example .env
   ```
   To enable the translation feature in the app, register on [Deepl.com](https://www.deepl.com/uk/signup?cta=free-login-signup)  
   subscribe to the DeepL API Free plan, and obtain the DeepL API Key.
   Update the memory-cards/memory_cards/.env file:
   ```bash
   TRANSLATE_SERVICE=deepl
   TRANSLATE_API_KEY=your_deepl_api_key
   ```
   To enable the pronunciation feature, register and obtain a key from [responsivevoice.org](https://responsivevoice.org/register/)  
   Update the memory-cards/memory_cards/.env file:
   ```bash
   VOICE_KEY=your_key
   ```
4. Create and run Docker containers:
   ```bash
   docker-compose up -d --build
   ```
5. Install dependencies:
   ```bash
   docker exec php_app composer install
   docker exec php_app npm install
   ```
6. Run migrations:
   ```bash
   docker exec php_app php artisan migrate
   ```
7. Start Vite:
   ```bash
   docker exec php_app npm run dev
   ```
8. The application should open at http://localhost.

## License

This project is licensed under a proprietary license. All rights are reserved by the author. Any use, modification, or  
distribution of this application or its source code without prior permission is strictly prohibited.

For inquiries regarding licensing, please contact: [yemcoder@gmail.com](mailto:yemcoder@gmail.com).  

### Čeština
## O aplikaci

Aplikace pomáhá rozšiřovat slovní zásobu cizích slov. Používají se kartičky – cizí slova a jejich překlad se zobrazují   
na pozadí různých barev. Barvy činí informace pestřejšími, přitahují pozornost a vytvářejí „kotvu“ pro paměť. Různé   
barvy aktivují různé oblasti mozku, což pomáhá lépe si informace spojit a odlišit.

V aplikaci lze studovat několik jazyků současně. Pro každý jazyk je možné vytvořit skupiny, například "Nová", "Měsíce",   
"Čísla", "Naučená". Při přidávání slov se vybírá již vytvořená skupina. Je také možné přeložit slovo jak z cizího jazyka   
do rodného, tak i opačně.

Na hlavní stránce aplikace se zobrazují cizí slova na barevném pozadí. Kliknutím na pozadí se zobrazí překlad slova.   
Dalším kliknutím se zobrazí další slovo z vybrané skupiny. Na stejné stránce je možné poslechnout si výslovnost cizího   
slova, upravit jej nebo odstranit.

Demo: https://mcards.fun/demo

## UI

### Sekce "Jazyky"
Po registraci je v sekci "Jazyky / Přidat jazyk" nutné přidat jazyky, které chcete studovat.
Poté musíte zvolit svůj rodný jazyk v sekci "Jazyky / Váš rodný jazyk" a jazyk, který budete nyní studovat, v sekci   
"Jazyky / Studovaný". V sekci "Jazyky / Jazyky" můžete vybrané jazyky upravit nebo odstranit.

### Sekce "Skupiny"
Zde je třeba zvolit jazyk, pro který se skupiny vytvářejí nebo upravují.
V sekci "Skupiny / Přesun" lze kartičky přesunout z jedné skupiny do jiné.

### Sekce "Import"
V této sekci lze importovat soubor CSV, kde první sloupec obsahuje cizí slovo a druhý jeho překlad. Před importem je   
nutné zvolit skupinu, ve které budou kartičky uloženy.

### Sekce "Přidat"
První pole slouží k zadání cizího slova, druhé k zadání jeho překladu. Každé vstupní pole obsahuje tlačítko pro překlad.   
Při uložení nebo importu se barva kartičky vytvoří automaticky.

### Sekce "Hlavní"
V této sekci se zobrazují kartičky. Vyberte skupinu kartiček, kterou chcete studovat. Kliknutím na pozadí se zobrazí   
překlad, opětovným kliknutím se zobrazí další kartička. Pod kartičkami se nachází menu, pomocí kterého můžete přehrát   
výslovnost cizího slova, upravit jej nebo odstranit.

## Instalace
Aplikace používá následující stack: Laravel 11.30.0, PHP 8.3, MySQL 8.0, Vue 3, Nginx Alpine, Docker Compose, Bootstrap 5,   
TailWindCSS a Vite. Pro instalaci aplikace musíte mít ve svém systému nainstalovaný [Docker Desktop](https://www.docker.com/products/docker-desktop/),
a volitelně Git.

1. Naklonujte tento repozitář do instalační složky:
   ```bash
   git clone https://github.com/AlexandrYemelyanov/memory-cards.git
   ```
   Nebo stáhněte archiv a rozbalte jej do instalační složky, pokud Git není nainstalovaný.
2. Změna adresáře:
   ```bash
   cd memory-cards/memory_cards/
   ```
3. Vytvoření souboru prostředí:
   ```bash
   cp .env.example .env
   ```
   Aby v aplikaci fungoval překlad, je nutné se zaregistrovat na [Deepl.com](https://www.deepl.com/uk/signup?cta=free-login-signup)  
   získat předplatné DeepL API Free a obdržet DeepL API Key.
   Proveďte změny v souboru memory-cards/memory_cards/.env:
   ```bash
   TRANSLATE_SERVICE=deepl
   TRANSLATE_API_KEY=your_deepl_api_key
   ```
   Aby fungovalo přehrávání výslovnosti cizích slov, je nutné se zaregistrovat a získat klíč na [responsivevoice.org](https://responsivevoice.org/register/)  
   Proveďte změny v souboru memory-cards/memory_cards/.env:
   ```bash
   VOICE_KEY=your_key
   ```
4. Vytvoření a spuštění Docker kontejnerů:
   ```bash
   docker-compose up -d --build
   ```
5. Instalace závislostí:
   ```bash
   docker exec php_app composer install
   docker exec php_app npm install
   ```
6. Spuštění migrací:
   ```bash
   docker exec php_app php artisan migrate
   ```
7. Spuštění Vite:
   ```bash
   docker exec php_app npm run dev
   ``` 
8. Na adrese http://localhost by se měla aplikace otevřít.

## License
Tento projekt je licencován pod proprietární licencí. Veškerá práva jsou vyhrazena autorem. Jakékoli použití, úprava   
nebo šíření této aplikace či jejího zdrojového kódu bez předchozího souhlasu je přísně zakázáno.  
Pro dotazy týkající se licencování nás prosím kontaktujte na: yemcoder@gmail.com.


### Russian
## О приложении

Приложение помогает увеличить словарный запас иностранных слов. Используются карточки - иностранные слова и их перевод
отображаются на фоне, имеющим различный цвет. Цвета делают информацию более разнообразной, что привлекает внимание и 
создает «якорь» для памяти. Разные цвета активируют различные области мозга, помогая лучше ассоциировать и 
дифференцировать информацию.

В приложении можно одновременно изучать несколько языков. Для каждого языка можно создать группы, например "Новые",
"Месяцы", "Числа", "Выучил". При добавлении слов, выбирается ранее созданная группа. Есть возможность перевести слово, 
как с изучаемого языка на ваш родной язык, так и наоборот.

На главной странице приложения отображаются иностранные слова на цветном фоне. При клике по фону будет показан перевод
слова. При следующем клике будет показано следующее слово из выбранной группы. Тут же можно прослушать произношение
иностранного слова, отредактировать или удалить его.

Демо: https://mcards.fun/demo

## UI

### Раздел "Языки"
После регистрации в разделе "Языки / Добавить язык" необходимо добавить языки, которые вы будете изучать.
Дальше необходимо выбрать ваш родной язык в разделе "Языки / Ваш родной язык", а в разделе "Языки / Изучаем" выбрать 
язык, которые будете сейчас изучать.
В Разделе "Языки / Языки" можно изменить или удалить выбранные языки.

### Раздел "Группы"
Здесь необходимо выбрать язык для которого создаются / редактируются группы.
В разделе "Группы / Перемещение" можно переместить карточки с одной группы в другую.

### Раздел "Импорт"
В этом разделе можно импортировать csv файл, в котором первая колонка - иностранное слово, вторая - перевод. Перед 
импортом необходимо выбрать группу, в которой будут сохранены карточки.

### Раздел "Добавить"
Первое поле для ввода иностранного слова, второе для перевода. В каждом поле ввода есть кнопка перевода. При сохранении
или импорте цвет для карточки будет создан автоматически

### Раздел "Главная"
Здесь отображаются карточки. Выберите группу карточек, которую хотите запомнить. При клике по фону, появится перевод, 
при повторном клике будет отображена следующая карточка. Ниже карточки отображено меню с помощью которого можно
прослушать произношение иностранного слова, изменить или удалить карточку.

## Установка
Приложение использует стек Laravel 11.30.0, PHP 8.3, MySQL 8.0, Vue 3, Nginx Alpine, Docker Compose, Bootstrap 5, 
TailWindCSS, Vite. Для установки в вашей системе должен быть установлен [Docker Desktop](https://www.docker.com/products/docker-desktop/), 
Git (опционально) 

1. Клонируйте этот репозиторий в папку установки:
   ```bash
   git clone https://github.com/AlexandrYemelyanov/memory-cards.git
   ```
   Или скопируйте архив и распакуйте его в папку установки, если у вас Git не установлен.
2. Смена директории:
   ```bash
   cd memory-cards/memory_cards/
   ```
3. Создание файла окружения:
   ```bash
   cp .env.example .env
   ```
   Для того чтобы в приложении работал перевод, необходимо зарегистрироваться на [Deepl.com](https://www.deepl.com/uk/signup?cta=free-login-signup)  
   Получить подписку DeepL API Free и получить DeepL API Key.  
   Внести изменения в файл memory-cards/memory_cards/.env  
   ```bash
   TRANSLATE_SERVICE=deepl
   TRANSLATE_API_KEY=your_deepl_api_key
   ```
   Чтобы работало озвучивание иностранных слов, необходимо зарегистрироваться и получить ключ на [responsivevoice.org](https://responsivevoice.org/register/)  
   Внести изменения в файл memory-cards/memory_cards/.env
   ```bash
   VOICE_KEY=your_key
   ```
4. Создание и запуск docker контейнеров:
   ```bash
   docker-compose up -d --build
   ```
5. Установка зависимостей:
   ```bash
   docker exec php_app composer install
   docker exec php_app npm install
   ```
6. Запуск миграций:
   ```bash
   docker exec php_app php artisan migrate
   ```
7. Запуск Vite:
   ```bash
   docker exec php_app npm run build
   ``` 
8. По адресу http://localhost должно открыться приложение   
## License

This project is licensed under a proprietary license. All rights are reserved by the author. Any use, modification,   
or distribution of this application or its source code without prior permission is strictly prohibited.

For inquiries regarding licensing, please contact: [yemcoder@gmail.com](mailto:yemcoder@gmail.com).
