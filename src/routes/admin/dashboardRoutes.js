const express = require("express");
const router = express.Router();
const dashboardController = require("../../controllers/admin/dashboardController");

// Dashboard
router.get("/dashboard", dashboardController.dashboard);

module.exports = router;
