const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/contactController");

// Contact info
router.get("/info", controller.getContactInfo);

// Send message
router.post("/send-message", controller.sendMessage);

module.exports = router;
