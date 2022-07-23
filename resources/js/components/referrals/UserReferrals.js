import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import ReferralEmailsForm from './ReferralEmailsForm';
import ReferralPoints from './ReferralPoints';
import ReferralsList from './ReferralsList';

const UserReferrals = (props) => {
    const [referrals, setReferrals] = useState(props.referrals)
    return (
        <>
            <ReferralEmailsForm onUpdateReferrals={setReferrals} />
            <ReferralPoints points={props.points} />
            <ReferralsList referrals={referrals} />
        </>
    )
};

export default UserReferrals;

if (document.getElementById('user-referrals')) {
    const userReferralsElement = document.getElementById('user-referrals')

    const referrals = JSON.parse(userReferralsElement.getAttribute('referrals'))
    const points = userReferralsElement.getAttribute('points')

    ReactDOM.render(
        <UserReferrals referrals={referrals} points={points} />,
        userReferralsElement
    );
}
