import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import ReferralsTable from './ReferralsTable';

const ReferralsList = (props) => {
    const referrals = props.referrals
    return (
        <div className="card">
            <div className="card-header">Referrals</div>
            <div className="card-body">
                {referrals.length === 0
                    ? <span>You haven't sent any referral links yet. Invite your friends now!</span>
                    : <ReferralsTable referrals={referrals} />
                }
            </div>
        </div>
    )
};

export default ReferralsList;
