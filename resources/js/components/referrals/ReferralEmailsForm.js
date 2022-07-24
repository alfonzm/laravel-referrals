import React, { useState } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import toast, { Toaster } from 'react-hot-toast'
import { ReactMultiEmail, isEmail } from 'react-multi-email'
import 'react-multi-email/style.css'

const ReferralEmailsForm = ({ onUpdateReferrals }) => {
    const [emails, setEmails] = useState([])
    const [errorMessage, setErrorMessage] = useState(null)

    function getLabel(email, index, removeEmail) {
        return (
            <div data-tag key={index}>
                {email}
                <span data-tag-handle onClick={() => removeEmail(index)}>
                ×
                </span>
            </div>
        )
    }

    async function handleSubmit(event) {
        event.preventDefault()
        axios.post('/referrals', { emails })
            .then(response => {
                setEmails([])
                onUpdateReferrals(response.data.referrals)
                toast.success('Invite emails sent!', { icon: '👍' })
                setErrorMessage(null)
            })
            .catch(error => {
                const { response: { data } } = error
                const errors = Object.entries(data.errors).map(error => error[1][0])
                setErrorMessage(errors.map(error => <>
                    {error}<br />
                </>))
            })
    }

    return (
        <>
            <div className="card mb-5">
                <div className="card-header">Invite a Friend</div>
                <div className="card-body">
                    <p>Send referral links</p>
                    <div>
                        <form onSubmit={handleSubmit}>
                            <ReactMultiEmail
                                emails={emails}
                                onChange={setEmails}
                                getLabel={getLabel}
                                placeholder="email@email.com"
                                validatedEmail={isEmail}
                            />
                            <p className="text-danger">
                                {errorMessage}
                            </p>
                            <input className="btn btn-primary" type="submit" />
                        </form>
                    </div>
                </div>
            </div>
            <Toaster />
        </>
    )
}

export default ReferralEmailsForm
