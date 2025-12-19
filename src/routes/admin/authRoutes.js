const express = require("express");
const router = express.Router();

// 🔴 VERY IMPORTANT: path EXACT ho
const authController = require("../../controllers/api/authController");

// TEST LOG (temporary)
console.log("AUTH CONTROLLER:", authController);

router.post("/register", authController.register);
//router.post("/login", authController.login);

module.exports = router;
