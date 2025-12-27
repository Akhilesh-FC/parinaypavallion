const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/propertyController");

/* ========= LAWNS ========= */
router.get("/lawns", (req, res) => controller.listByType(req, res, "lawn"));
router.get("/lawns/add", (req, res) => controller.addForm(req, res, "lawn"));
router.post("/lawns/add", (req, res) => controller.store(req, res, "lawn"));
router.get("/lawns/edit/:id", controller.editForm);
router.post("/lawns/edit/:id", controller.update);
router.get("/lawns/delete/:id", controller.delete);

/* ========= HALLS ========= */
router.get("/halls", (req, res) => controller.listByType(req, res, "hall"));
router.get("/halls/add", (req, res) => controller.addForm(req, res, "hall"));
router.post("/halls/add", (req, res) => controller.store(req, res, "hall"));
router.get("/halls/edit/:id", controller.editForm);
router.post("/halls/edit/:id", controller.update);
router.get("/halls/delete/:id", controller.delete);

/* ========= ROOMS ========= */
router.get("/rooms", (req, res) => controller.listByType(req, res, "room"));
router.get("/rooms/add", (req, res) => controller.addForm(req, res, "room"));
router.post("/rooms/add", (req, res) => controller.store(req, res, "room"));
router.get("/rooms/edit/:id", controller.editForm);
router.post("/rooms/edit/:id", controller.update);
router.get("/rooms/delete/:id", controller.delete);

module.exports = router;
