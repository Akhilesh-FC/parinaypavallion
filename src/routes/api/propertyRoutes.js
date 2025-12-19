const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/propertyController");

router.get("/list", controller.list);
router.get("/counts", controller.countProperties);

module.exports = router;
