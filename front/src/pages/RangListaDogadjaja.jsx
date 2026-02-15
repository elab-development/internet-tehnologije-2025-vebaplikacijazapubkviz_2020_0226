import React, { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Navbar from "../components/Navbar";
import PageHeader from "../components/PageHeader";
import Loader from "../components/Loader";
import DataTable from "../components/DataTable";
import TeamRow from "../components/TeamRow";
import Button from "../components/Button";
import { useDogadjaji } from "../hooks/useDogadjaji";
import { useAuth } from "../hooks/useAuth";

const RangListaDogadjaja = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { role } = useAuth();

  const { podaci, naslovDogadjaja, fetchRangLista, loading,updateScore } = useDogadjaji();
    const isAdmin = role === "moderator";


  
  const handleUpdateScore = async (timId, noviScore) => {
    const result = await updateScore(timId, id, noviScore);

    if (result.success) {
      fetchRangLista(id);
      return true;
    } else {
      alert(result.error);
    }
  };


  useEffect(() => {
    fetchRangLista(id);
  }, []);

  if (loading) return <Loader fullPage message="Učitavam poretke timova..." />;

  return (
    <div className="min-h-screen bg-gray-50/50 text-gray-900 pb-20">
      <Navbar />
      <div className="p-8 md:p-12 w-full max-w-7xl mx-auto">
        <Button type="secondary" onClick={() => navigate(-1)}>
          Nazad
        </Button>
        <PageHeader
          title="Rezultati"
          highlight="Kola"
          subtitle={`Događaj: ${naslovDogadjaja}`}
        />

        {podaci.length > 0 ? (
          <DataTable
            headers={["Rank", "Ekipa", "Osvojeni Bodovi"]}
            variant="indigo"
          >
            {podaci.map((tim, index) => (
              <TeamRow
                key={tim.tim_id || index}
                index={index}
                tim={tim}
                 isAdmin={isAdmin}
                onUpdate={handleUpdateScore}
              />
            ))}
          </DataTable>
        ) : (
          <div className="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-100">
            <p className="text-gray-400 font-bold italic text-lg text-center w-full">
              Rezultati za ovaj događaj još uvijek nisu uneseni.
            </p>
          </div>
        )}

       
      </div>
    </div>
  );
};

export default RangListaDogadjaja;
