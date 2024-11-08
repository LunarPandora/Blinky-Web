import { ref, onMounted } from 'vue'
import { defineStore } from 'pinia'

export const useSessionStore = defineStore('session', () => {
    const isAuthenticated = ref(false)
    const session = ref({
        id: '-',
        role: '-',
        acc_id: '-',
        // username: '',
    })

    // ===================================================================

    function refreshSession(){
        if(localStorage.getItem('isAuthenticated') != null){
            isAuthenticated.value = JSON.parse(localStorage.getItem('isAuthenticated'))
        }
    
        if(localStorage.getItem('user_session_blinky') != null){
            session.value = JSON.parse(localStorage.getItem('user_session_blinky'))
        }
    }

    // ===================================================================


    function resetSession(){
        session.value = {
            id: '-',
            role: '-',
            acc_id: '-',
        }
    }

    function registerSession(user){
        session.value = user
    }

    function authenticate(){
        isAuthenticated.value = true
        localStorage.setItem('isAuthenticated', JSON.stringify(isAuthenticated.value))

        localStorage.setItem('user_session_blinky', JSON.stringify(session.value))
    }

    function inauthenticate(){
        isAuthenticated.value = false
        localStorage.setItem('isAuthenticated', JSON.stringify(isAuthenticated.value))

        resetSession()
        localStorage.setItem('user_session_blinky', JSON.stringify(session.value))
    }

    return { isAuthenticated, session, authenticate, inauthenticate, registerSession, resetSession, refreshSession }
})