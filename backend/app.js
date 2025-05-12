import express from "express";
import categories from "./routes/categories.js";
import login from "./routes/login.js";
import products from "./routes/products.js";
import cors from "cors"

const app = express();
const port = 3000;

app.use(express.json());
app.use(cors())
// login user
app.use("/login", login);
// Get all categories
app.use("/categories", categories);
// Get all products
app.use("/products", products);


app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
