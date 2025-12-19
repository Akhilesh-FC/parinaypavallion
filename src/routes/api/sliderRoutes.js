const express = require("express");
const router = express.Router();
const sliderController = require("../../controllers/api/sliderController");

// Get sliders
router.get("/list", sliderController.list);

// Create slider (for now open, later secure)
router.post("/create", sliderController.create);

module.exports = router;
