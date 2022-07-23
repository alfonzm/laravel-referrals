import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const ReferralsList = (props) => {
    const referrals = props.referrals
    return (
        <div className="card">
            <div className="card-header">Referrals</div>
            <div className="card-body">
                {referrals.length === 0
                    ? <span>You haven't sent any referral links yet. Invite your friends now!</span>
                    :
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
                }
            </div>
        </div>
    )
};

export default ReferralsList;
