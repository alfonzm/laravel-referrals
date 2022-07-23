import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const ReferralsTable = ({ referrals, showReferrer }) => {
    return (
        <table className="table">
            <thead>
                <tr>
                    {showReferrer && <th>Referrer</th>}
                    <th>Recipient Email</th>
                    <th>Updated</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {referrals.map(referral => (
                    <tr key={referral.id}>
                        {showReferrer && <td>{referral.referrer.name} ({referral.referrer.email})</td>}
                        <td>{referral.recipient_email}</td>
                        <td>{new Date(referral.updated_at).toLocaleString('en-US')}</td>
                        <td>{referral.formattedStatus}</td>
                    </tr>
                ))}
            </tbody>
        </table>
    )
};

export default ReferralsTable;
