const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/hallController");

router.get("/list", controller.listHalls);

module.exports = router;
