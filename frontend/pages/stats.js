import {Box, Typography}from "@mui/material";
import {useState} from "react";
import defineTitle from "../services/defineTitle";
import useSWR from "swr";

const fetcher = (...args) => fetch(...args).then((res) => res.json())

function Stats() {

    const {data, error} = useSWR('http://127.0.0.1:8000/api/reponses/', fetcher)

    if (data) {
        defineTitle(`Stats`)
    }
    console.log(data)

    return (<Box>
        {!data ? (
            <Typography variant="h1" sx={{textAlign: "center", fontSize: '45px'}} gutterBottom>Chargement des stats...</Typography>
        ) : (
            <Box>
                <Typography variant="h1" sx={{textAlign: 'center', mb: 4, fontSize: '45px'}} id="new-type-title">Liste des stats</Typography>
                <Typography variant="h2" sx={{textAlign: 'start', mb: 4, fontSize: '30px'}} id="new-type-title">Total de {data.data.length} réponses</Typography>
                {data.data.map((stat) => {
                    return(
                        <Box key={stat.id}>

                        </Box>
                    )
                })}
            </Box>
        )}
    </Box>
    )
}

export default Stats;