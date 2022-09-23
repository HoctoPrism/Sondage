import {Box, Typography, Link}from "@mui/material";
import {useEffect, useState} from "react";
import axios from "axios";

function Sondage() {

    const [sondages, setSondage] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/sondages').then((actualData) => {
            actualData = actualData.data;
            setSondage(actualData.data)
            setLoading(false)
        }).catch((err) => {
            setLoading(true)
            console.log(err)
        })
    }, [])

    return (<Box>
        {loading ? (
            <Typography variant="h1" sx={{textAlign: "center", fontSize: '45px'}} gutterBottom>Chargement des parkings...</Typography>
        ) : (
            <Box>
                <Typography variant="h1" sx={{textAlign: 'center', mb: 4, fontSize: '45px'}} id="new-type-title">Liste des sondages</Typography>
                {sondages.map((sondage) => {
                    return (
                        <Typography variant='h2' sx={{fontSize: '25px', mb: 5}} key={sondage.name+sondage.id} >
                            <Link underline="none" href={ '/sondage/participe/' + sondage.id }>{sondage.name}</Link>
                        </Typography>
                    )
                })}
            </Box>
        )}
    </Box>
    )
}

export default Sondage;