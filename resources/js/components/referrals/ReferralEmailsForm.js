import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { ReactMultiEmail, isEmail } from 'react-multi-email';
import axios from 'axios';
import 'react-multi-email/style.css';

const ReferralEmailsForm = () => {
    const [emails, setEmails] = useState([]);
    const [errorMessage, setErrorMessage] = useState(null);

    function getLabel(email, index, removeEmail) {
        return (
            <div data-tag key={index}>
                {email}
                <span data-tag-handle onClick={() => removeEmail(index)}>
                ×
                </span>
            </div>
        );
    }

    async function handleSubmit(event) {
        event.preventDefault();
        setErrorMessage(null);
        axios.post('/referrals', { emails })
            .then(response => {
                setEmails([])
                alert('Referral emails sent!')
            })
            .catch(error => {
                const { response: { data } } = error
                const errors = Object.entries(data.errors).map(error => error[1][0])
                setErrorMessage(errors.join(' '))
            });
    }

    return (
        <form onSubmit={handleSubmit}>
            <ReactMultiEmail
                emails={emails}
                onChange={setEmails}
                getLabel={getLabel}
                placeholder="email@email.com"
                validatedEmail={isEmail}
            />
            <p class="text-danger">
                {errorMessage}
            </p>
            <input className="btn btn-primary" type="submit" />
        </form>
    )
};

export default ReferralEmailsForm;

if (document.getElementById('referral-emails-form')) {
    ReactDOM.render(<ReferralEmailsForm />, document.getElementById('referral-emails-form'));
}
