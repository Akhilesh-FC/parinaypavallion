const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/lawnController");

router.get("/lawns_list", controller.listLawns);

module.exports = router;
