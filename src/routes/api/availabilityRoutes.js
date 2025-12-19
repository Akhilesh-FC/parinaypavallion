const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/availabilityController");

// dropdown
router.get("/venues", controller.getVenuesForDropdown);

// event types
router.get("/event-types", controller.getEventTypes);

// check availability
router.get("/check", controller.checkAvailability);

module.exports = router;
