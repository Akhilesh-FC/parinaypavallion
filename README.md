parinay-pavilion
│  server.js
│  .env
│  README.md
│
└──src
    ├──app.js
    ├──config
    │   └──database.js
    ├──models
    │   ├──Admin.js
    │   └──Enquiry.js
    ├──controllers
    │   ├──api
    │   │   └──enquiryController.js
    │   └──admin
    │       ├──adminAuthController.js
    │       └──enquiryController.js
    ├──routes
    │   ├──api
    │   │   └──enquiryRoutes.js
    │   └──admin
    │       ├──authRoutes.js
    │       └──enquiryRoutes.js
    └──middlewares
        └──adminAuth.js
