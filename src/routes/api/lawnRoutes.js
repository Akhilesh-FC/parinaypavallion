const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/lawnController");

router.get("/lawns_list", controller.listLawns);
router.get("/:id", controller.getLawnDetails);

module.exports = router;
