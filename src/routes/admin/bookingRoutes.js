const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/bookingController");

// All bookings
router.get("/bookings", controller.allBookings);

// Pending approval
router.get("/bookings/pending", controller.pendingBookings);

// Approve / Reject
router.post("/bookings/approve/:id", controller.approveBooking);
router.post("/bookings/reject/:id", controller.rejectBooking);

// Export
router.get("/bookings/export", controller.exportPage);

module.exports = router;
