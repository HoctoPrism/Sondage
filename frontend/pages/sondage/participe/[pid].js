import {Alert, Box, Button, FormControl, InputLabel, MenuItem, Select, Snackbar, Typography} from "@mui/material";
import {useState} from "react";
import {useRouter} from "next/router";
import useSWR from "swr";
import defineTitle from "../../../services/defineTitle";
import update from "immutability-helper";
import axios from "axios"
import {getCsrfToken} from "next-auth/react";

const fetcher = (...args) => fetch(...args).then((res) => res.json())

function New({csrfToken = getCsrfToken()}) {

    const router = useRouter()

    const [id, setID] = useState("");
    const [result, setResult] = useState([]);
    // Handle Toast event
    const [toast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState({});

    const {pid} = router.query;

    const {data, error} = useSWR('http://127.0.0.1:8000/api/sondages/' + pid, fetcher)

    if (data) {
        defineTitle(`Sondage : ${data.data.name}`)
    }

    let newSondageForm = async (e) => {
        e.preventDefault()
        try {
            console.log(result)
            let res = await axios.post('/api/reponses', {result})
            if (res.status === 200) {
                setResult([]);
                setToastMessage({message: "Le sondage a été envoyé !", severity: "success"});
                setShowToast(true);
            } else {
                setToastMessage({message: "Une erreur est survenue", severity: "error"});
            }
        } catch (err) {
            console.log(err);
        }
    }

    let handleResponse = (question, response) => {
        let array = result;
        const foundIndex = array.findIndex(x => x.ask === question);
        if (foundIndex >= 0) {
            let final = update(array, {[foundIndex]: {$set: {'ask': question, 'response': response, 'sondage': pid}}})
            setResult(final)
        } else {
            let final = update(array, {$push: [{'ask': question, 'response': response, 'sondage': pid}]})
            setResult(final)
        }
    }

    return (<Box>
            {!data ? (
                <Typography variant="h1" sx={{textAlign: "center", fontSize: '45px'}} gutterBottom>Chargement des sondage...</Typography>
            ) : (
                <Box>
                    <Typography variant="h4" sx={{textAlign: 'center', mb: 4}} id="sondage-title">{data.data.name.toUpperCase()}</Typography>
                    <form onSubmit={(e) => newSondageForm(e)} className='f-c-c-c'>
                        {data.data.questions.map((question) => {
                            return (
                                <FormControl key={question.id} sx={{m: 1, mt: 5, minWidth: 120, width: 500}}>
                                    <InputLabel id="sondage-select">{question.name}</InputLabel>
                                    <Select
                                        name='sondage'
                                        labelId="sondage-select"
                                        id="sondage-select"
                                        label="sondage"
                                        onChange={(e) => handleResponse(question.id, e.target.value)}
                                        sx={{height: 50}}
                                        variant='filled'
                                    >
                                        {question.propositions.map((propal) => {
                                            return (
                                                <MenuItem key={propal.id} value={propal.id}>{propal.name}</MenuItem>
                                            )
                                        })}
                                    </Select>
                                </FormControl>
                            )
                        })}
                        <Button type="submit" sx={{m: 3}} variant="contained">Envoyer</Button>
                    </form>

                    <Snackbar
                        open={toast}
                        autoHideDuration={3000}
                        onClose={() => setShowToast(false)}
                        anchorOrigin={{vertical: 'bottom', horizontal: 'center'}}
                    >
                        <Alert onClose={() => setShowToast(false)} severity={toastMessage.severity}
                               sx={{width: '100%'}}>
                            {toastMessage.message}
                        </Alert>
                    </Snackbar>
                </Box>)}
        </Box>
    )
}

export default New;