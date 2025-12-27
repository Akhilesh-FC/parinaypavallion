const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/bookingController");
const auth = require("../../middlewares/apiAuth");

router.post("/create", auth, controller.createBooking);
router.post("/pay-installment", auth, controller.payInstallment);
router.get("/my-bookings", auth, controller.myBookings);

module.exports = router;
