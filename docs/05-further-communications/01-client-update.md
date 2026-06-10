# Add Page - Further Communcation - Viktar Kruhlikau - Confluence

Viktar Kruhlikau

/

Further Communcation

Saved

* ![Viktar Kruhlikau](/wiki/aa-avatar/712020:638647e0-9d3d-44f1-a79d-ddaf8b900c0a)
  V


Publish...

Close

Share

Copy link

More actions

Help

Write

Normal text

* Emoji
* Status
* Header image
* Suggest title
* Use compact density


# Further Communcation

Further Communcation

, Add Page

![](/wiki/aa-avatar/712020:638647e0-9d3d-44f1-a79d-ddaf8b900c0a)

By Viktar Kruhlikau

3 min

Listen

![App Icon](https://icon.cdn.prod.atlassian-dev.net/e63e8314-80d8-4c90-8697-923c6e01fcfb/13cda2c3-db92-4c9c-99cd-dc030217fcac/65805ae5-47e5-4d12-bbfd-84c76162ee32/main/icons/add.svg)Add approval

Collapse action bar

View all comments

Open Details Panel

Open Rovo Chat

Floating toolbar controls have been opened

2 Columns

Drag to move ,\[object Object\], Click to open menu

Существует 2 функции, для которых требуется автологин.

**#1 Elsbeth-Powerdialing (Звонок должникам) вручную или автоматически:**

Внутренний диалог PHP «Ticket» вызывается из клиентской программы через существующее соединение с сервером SaaS. Обработка происходит на стороне сервера в PHP. Окно с результатами отображается на стороне клиента в отдельном встроенном браузерном элементе управления, благодаря чему каждый вызов диалога отображается отдельно и наглядно.

PHP-диалог «Ticket» ([https://10.196.69.11/kimi\_ET/index.php?site=ticket&.](https://10.196.69.11/kimi_ET/index.php?site=ticket&.).. ) является частью внутреннего клиентского приложения Elsbeth PowerContact и вызывается из клиентской программы.

Клиентская программа имеет существующее соединение с сервером SaaS и при установке телефонного соединения / вызове диалога передает необходимую контекстную информацию, такую как данные пользователя, клиента или операции.

Диалог обрабатывается на стороне сервера с помощью приложения PHP, а затем отображается на стороне клиента.

При этом результаты отображаются не в главном окне приложения, а в отдельном встроенном элементе управления браузера.

Благодаря этому каждый вызов диалога отображается отдельно с технической точки зрения и может отображаться независимо от остального контекста программы.

Порядок действий и информация

Подготовка

└── Загрузка файла в Elsbeth через Admin с помощью «kimi-link»  
└── Ручной или автоматический вызов — ссылка запускается  
└── loginuser заменяется в Elsbeth на kimi-user



Клиентская программа (ELSBETH-Power-Client)  
└── Подключение к SaaS-серверу  
└── Вызов внутреннего диалога PHP «Call-Ticket»  
└── Передача контекстных данных, например, номер клиента, номер операции, пользователь, сессия/токен -- ссылка вызова

PHP-приложение / портал KIMI  
└── Обработка запроса  
├── Проверка переданных данных  
├── Загрузка данных билета  
├── Отображение диалога в элементе управления браузера



Отображение результатов  
└── Отображение осуществляется в отдельном встроенном элементе управления браузера  
├── Отдельный элемент управления браузера для каждого вызова диалога  
├── Независимое отображение и редактирование окна результатов  
└── Отсутствие прямого смешивания с другими диалоговыми окнами



ELSBET — поле «Ссылка KIMI»:

[https://10.196.69.11/kimi\_ET/index.php?autologin=true&loginuser=elsbeth&mandant=41&kId=35&ticket\_id=1005976&](https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=elsbeth&mandant=41&kId=35&ticket_id=1005976&)site=ticket&selected\_tickets=1005976&selected\_ticket\_index=0&noHeader=true&telefonStarten=N



Отображение клиента Elsbeth с помощью объекта браузера

![78eea526-70d1-4915-824e-9af31e5670cc.png]


**#2 Вызовы KIMI в Call-Manager:**

При поступлении входящих вызовов система ищет заявку по номеру телефона и внутреннему номеру вызова и отображает ссылку

[https://10.196.69.21/kimidev\_ET/setticketcallinfo.php](https://10.196.69.21/kimidev_ET/setticketcallinfo.php) – Поиск заявки по номеру телефона

[https://10.196.69.11/kimi\_ET/index.php?autologin=true&loginuser=tauschfranz&mandant=40&kId=34&ticket\_id=28891&site=ticket&selected\_tickets=28891&selected\_ticket\_index=0](https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=tauschfranz&mandant=40&kId=34&ticket_id=28891&site=ticket&selected_tickets=28891&selected_ticket_index=0)

Прямой вызов с автологином в Call-Manager – ссылку см. в разделе «Пропущенные» или «Aктуальные звонки»

![image-20260520-144038.png]

Я хотел бы уточнить, достаточно ли вам предоставленной информации?

**Что касается тестовой базы данных и порядка проведения тестов, я хотел бы обсудить возможный план действий, прежде чем приступать к дальнейшим шагам.**

Речь идет о том, что конкретно мы можем предоставить. У нас есть среда разработки, к которой мы также можем предоставить вам доступ.

Прошу предложить удобное для вас время.



