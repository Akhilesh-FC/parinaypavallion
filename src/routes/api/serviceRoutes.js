const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/serviceController");

router.get("/list", controller.list);
router.get("/featured_venue_list", controller.featured_venue_list);

module.exports = router;
