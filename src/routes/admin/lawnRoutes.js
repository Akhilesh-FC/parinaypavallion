const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/lawnController");

router.get("/lawns", controller.list);
router.get("/lawns/add", controller.addPage);
router.post("/lawns/add", controller.store);

module.exports = router;
