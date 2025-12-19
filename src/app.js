const express = require("express");
const app = express();
const cors =require('cors')

app.use(express.json());
/* ✅ CORS CONFIG */
app.use(cors({
  origin: "*",
  methods: ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
  allowedHeaders: ["Content-Type", "Authorization"]
}));





app.get("/", (req, res) => {
  res.send("API Working");
});


app.use("/api/auth", require("./routes/api/authRoutes"));
app.use("/api/properties", require("./routes/api/propertyRoutes"));
//app.use("/api/gallery", require("./routes/api/galleryRoutes"));
app.use("/api/enquiry", require("./routes/api/enquiryRoutes"));
app.use("/api/slider", require("./routes/api/sliderRoutes"));
app.use("/api/services", require("./routes/api/serviceRoutes"));

app.use("/api/availability", require("./routes/api/availabilityRoutes"));
app.use("/api/lawns", require("./routes/api/lawnRoutes"));




module.exports = app;


