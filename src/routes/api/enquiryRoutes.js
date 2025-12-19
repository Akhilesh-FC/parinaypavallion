const express = require("express");
const router = express.Router();
const enquiryController = require("../../controllers/api/enquiryController");

router.post("/create", enquiryController.createEnquiry);

module.exports = router;


router.post("/send", require("../../controllers/api/enquiryController").send);
