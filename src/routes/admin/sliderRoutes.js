const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/sliderController");
const upload = require("../../middlewares/upload");

router.get("/sliders", controller.list);
router.post("/sliders/update/:id", upload.single("image"), controller.update);
router.get("/sliders/delete/:id", controller.delete);

module.exports = router;
