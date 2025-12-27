const express = require("express");
const app = express();
const cors = require("cors");
const path = require("path");
const session = require("express-session");

/* =========================
   BASIC MIDDLEWARES
========================= */

app.use('/Public', express.static(path.join(__dirname, 'Public')));

// JSON & FORM
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// CORS
app.use(cors({
  origin: "*",
  methods: ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
  allowedHeaders: ["Content-Type", "Authorization"]
}));

/* =========================
   SESSION (ADMIN LOGIN)
========================= */
app.use(
  session({
    secret: "parinayAdminSecret",
    resave: false,
    saveUninitialized: false
  })
);

/* =========================
   STATIC FILES
========================= */
//app.use("/public", express.static(path.join(__dirname, "Public")));
app.use("/assets", express.static(path.join(__dirname, "Public/assets")));


/* =========================
   VIEW ENGINE (ADMIN)
========================= */
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

/* =========================
   ROOT
========================= */
app.get("/", (req, res) => {
  res.send("API Working");
});

/* =========================
   API ROUTES
========================= */
app.use("/api/auth", require("./routes/api/authRoutes"));
app.use("/api/properties", require("./routes/api/propertyRoutes"));
app.use("/api/gallery", require("./routes/api/galleryRoutes"));
app.use("/api/slider", require("./routes/api/sliderRoutes"));
app.use("/api/services", require("./routes/api/serviceRoutes"));
app.use("/api/availability", require("./routes/api/availabilityRoutes"));
app.use("/api/lawns", require("./routes/api/lawnRoutes"));
app.use("/api/halls", require("./routes/api/hallRoutes"));
app.use("/api/rooms", require("./routes/api/roomRoutes"));
app.use("/api/contact", require("./routes/api/contactRoutes"));
app.use("/api/booking", require("./routes/api/bookingRoutes"));

/* =========================
   ADMIN ROUTES
========================= */
app.use("/admin", require("./routes/admin/authadminRoutes"));
app.use("/admin", require("./routes/admin/dashboardRoutes"));

app.use("/admin", require("./routes/admin/propertyRoutes"));

app.use("/admin", require("./routes/admin/bookingRoutes"));
app.use("/admin", require("./routes/admin/userRoutes"));
app.use("/admin/cms", require("./routes/admin/cmsRoutes"));
app.use("/admin/cms", require("./routes/admin/sliderRoutes"));
app.use("/admin", require("./routes/admin/settingRoutes"));



module.exports = app;
