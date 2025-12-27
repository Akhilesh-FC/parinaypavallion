const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/userController");
const adminAuth = require("../../middlewares/adminAuth");

// Registered users
router.get("/users", adminAuth, controller.listUsers);

// User booking history
router.get("/users/:id/bookings", adminAuth, controller.userBookings);

module.exports = router;
