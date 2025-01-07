"use client";

import { useEffect, useState } from "react";
import axios from "axios";

const Inventory = () => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    const fetchProducts = async () => {
      const response = await axios.get("http://localhost/api/inventory");
      setProducts(response.data);
    };

    fetchProducts();
  }, []);

  return (
    <div className="p-6 bg-gray-100">
      <h1 className="text-2xl font-bold mb-4">Inventory</h1>
      {products.map((product) => (
        <div key={product.id} className="bg-white p-4 rounded shadow mb-2">
          <p className="text-lg">{product.name}</p>
          <p>Stock: {product.stock}</p>
        </div>
      ))}
    </div>
  );
};

export default Inventory;
