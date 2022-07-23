import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const ReferralPoints = ({ points, maxPoints = 10 }) => {
    return (
        <div className="card mb-5">
            <div className="card-header">Referral Points</div>
            <div className="card-body">
                <p>You currently have <strong>{points}/{maxPoints}</strong> referral points.</p>
                <small class="text-muted">Note: You can only earn a maximum of {maxPoints} referral points. You can still invite your friends but you will no longer earn points.</small>
            </div>
        </div>
    )
};

export default ReferralPoints;
