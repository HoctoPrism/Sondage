import {AppBar, Box, Button} from "@mui/material";
import {SwitchModeButton} from "../../../services/theme/switchModeButton";
import {useEffect} from "react";
import Link from "next/link";
import LoginBtn from "../../../components/login-btn";

export default function Navbar() {

    useEffect(() => {
    }, [])

    return (
        <Box sx={{flexGrow: 1}}>
            <AppBar className='header' id="navbar">
                <Box sx={{m: 5, flexGrow: 1}} component="div">React-Next-Starter</Box>
                <Box className="navbar">
                    <Link href='/'><Button color="secondary">Accueil</Button></Link>
                    <Link href='/sondage'><Button color="secondary">Sondage</Button></Link>
                    <Link href='/stats'><Button color="secondary">Stats</Button></Link>
                    <Link href='/sondage/create'><Button color="secondary">Créer</Button></Link>
                    <LoginBtn/>
                    <SwitchModeButton/>
                </Box>
            </AppBar>
        </Box>
    )
}