import NextAuth from "next-auth"
import axios from "axios";
import CredentialsProvider from "next-auth/providers/credentials"

let finalUser = {};

export const authOptions = {
    session: {
        maxAge: 24 * 60 * 60 // the session will last 24h
    },
    pages: {
        signIn: "/login",
    },
    secret: process.env.NEXTAUTH_SECRET,
    // Configure one or more authentication providers
    providers: [
        CredentialsProvider({
            id: 'credentials',
            name: 'Credentials',
            credentials: {
                email: {label: "Email", type: "email", placeholder: "email@example.com"},
                password: {label: "Password", type: "password"},
            },
            async authorize(credentials) {
                let res = await axios.post("/api/login/", credentials, {
                    "headers": {"Content-Type": "multipart/form-data"}
                });

                // On attend dans le retour un token JWT contenant un name, email et roles
                if (res) {
                    finalUser = {
                        name: res?.user?.name,
                        email: res?.user?.email,
                    }
                    return finalUser
                } else {
                    return new Error( JSON.stringify({ errors: finalUser.errors, status: false }))
                }
            }
        })
    ],
    callbacks: {
        async session({session, token, user}) {
            if (!session?.user) {
                return session
            }
            session.user = finalUser
            return session
        }
    }
}

export default NextAuth(authOptions)