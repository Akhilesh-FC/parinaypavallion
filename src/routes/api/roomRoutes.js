const express = require("express");
const router = express.Router();
const controller = require("../../controllers/api/roomController");

router.get("/list", controller.listRooms);

module.exports = router;
