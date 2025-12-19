const router = require("express").Router();
const c = require("../../controllers/admin/propertyController");

router.post("/create", c.create);
router.get("/list", async (req,res)=>{
  const data = await require("../../models/Property").findAll();
  res.json({status:true,data});
});

module.exports = router;
