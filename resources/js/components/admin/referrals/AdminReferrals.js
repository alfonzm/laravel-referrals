import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import ReferralsTable from '../../referrals/ReferralsTable';

const AdminReferrals = (props) => {
    const referrals = props.referrals
    return (
        <div className="card">
            <div className="card-header">Referrals</div>
            <div className="card-body">
                {referrals.length === 0
                    ? <span>No referrals found.</span>
                    : <ReferralsTable referrals={referrals} showReferrer={true} />
                }
            </div>
        </div>
    )
};

export default AdminReferrals;

if (document.getElementById('admin-referrals')) {
    const adminReferralsElement = document.getElementById('admin-referrals')

    const referrals = JSON.parse(adminReferralsElement.getAttribute('referrals'))

    ReactDOM.render(
        <AdminReferrals referrals={referrals} />,
        adminReferralsElement
    );
}
