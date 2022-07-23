import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const ReferralsTable = (props) => {
    const referrals = props.referrals
    return (
        <table className="table">
            <thead>
                <tr>
                    <th>Recipient Email</th>
                    <th>Updated</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {referrals.map(referral => (
                    <tr key={referral.id}>
                        <td>{referral.recipient_email}</td>
                        <td>{referral.updated_at}</td>
                        <td>{referral.formattedStatus}</td>
                    </tr>
                ))}
            </tbody>
        </table>
    )
};

export default ReferralsTable;
