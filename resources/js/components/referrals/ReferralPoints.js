import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const ReferralPoints = ({ points }) => {
    return (
        <div className="card mb-5">
            <div className="card-header">Referral Points</div>
            <div className="card-body">
                You currently have <strong>{points}/10</strong> succesful referrals.
            </div>
        </div>
    )
};

export default ReferralPoints;
