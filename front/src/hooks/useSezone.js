import { useState } from "react";
import api from "../api";

export const useSezone = () => {
  const [sezone, setSezone] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [filters, setFilters] = useState({ pocetak: "", kraj: "" });
  const [currentPage, setCurrentPage] = useState(1);
  const [paginationMeta, setPaginationMeta] = useState(null);

  const [podaci, setPodaci] = useState([]);
  const [sezonaInfo, setSezonaInfo] = useState("");

  const updateFilters = (newFilters) => {
    setFilters((prev) => ({ ...prev, ...newFilters }));
    setCurrentPage(1);
  };

  const fetchSezone = async () => {
    setLoading(true);
    try {
      const response = await api.get("/sezone", {
        params: {
          ...filters,
          page: currentPage,
          per_page: 6,
        },
      });
      setSezone(response.data.data);
      setPaginationMeta(response.data.meta);
    } catch (error) {
      console.error("Greška pri učitavanju sezona:", error);
    } finally {
      setLoading(false);
    }
  };


  const fetchRangLista = async (id) => {
    setLoading(true);
    try {
      const response = await api.get(`/sezone/${id}/rang`);
      setPodaci(response.data.data);
      setSezonaInfo(response.data.sezona);
    } catch (error) {
      console.error("Greška pri učitavanju rang liste:", error);
    } finally {
      setLoading(false);
    }
  };

  return {
    sezone,
    loading,
    error,
    filters,
    updateFilters,
    currentPage,
    setCurrentPage,
    paginationMeta,
    podaci,
    sezonaInfo,
    fetchSezone,
    fetchRangLista,
  };
};
