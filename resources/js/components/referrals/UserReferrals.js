import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import ReferralEmailsForm from './ReferralEmailsForm';
import ReferralPoints from './ReferralPoints';
import UserReferralsList from './UserReferralsList';

const UserReferrals = (props) => {
    const [referrals, setReferrals] = useState(props.referrals)
    return (
        <>
            <ReferralEmailsForm onUpdateReferrals={setReferrals} />
            <ReferralPoints points={props.points} maxPoints={props.maxPoints} />
            <UserReferralsList referrals={referrals} />
        </>
    )
};

export default UserReferrals;

if (document.getElementById('user-referrals')) {
    const userReferralsElement = document.getElementById('user-referrals')

    const referrals = JSON.parse(userReferralsElement.getAttribute('referrals'))
    const points = Number(userReferralsElement.getAttribute('points'))
    const maxPoints = Number(userReferralsElement.getAttribute('maxPoints'))

    ReactDOM.render(
        <UserReferrals
            referrals={referrals}
            points={points}
            maxPoints={maxPoints}
        />,
        userReferralsElement
    );
}
