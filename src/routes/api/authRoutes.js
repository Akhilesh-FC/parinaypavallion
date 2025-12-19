const express = require("express");
const router = express.Router();
const auth = require("../../controllers/api/authController");

// 🔴 auth.login & auth.register MUST be functions
router.post("/register", auth.register);
router.post("/login", auth.login);

module.exports = router;
