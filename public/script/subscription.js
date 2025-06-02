const allPlans = [
    {
    id: 1,
    title: "Plan 1 – Free Subscription",
    description: `Free access to clickbait videos posted on our social media platforms.
    Free subscribers can ask questions in the comment section, and we’ll provide a brief answer.`
    },
    {
    id: 2,
    title: "Plan 2 – R350/yearly – Annual Subscription",
    description: `Full access to all clickbait-style videos. Downloadable resources, including cheat sheets and guides. Monthly tech tips newsletter.`
    },
    {
    id: 3,
    title: "Plan 3 – Personal Guide - R110/hour (students), R170/hour (business)",
    description: `One-on-one sessions via video/chat. Submit requests in advance. Flexible scheduling. Additional hours available.`
    },
    {
    id: 4,
    title: "Plan 4 – Formal Training - R400/students, R750/business",
    description: `Comprehensive EUC and web development training. Includes portfolio building and instructor-led sessions.`
    },
    {
    id: 5,
    title: "Plan 5 – Freelance Tutoring - R80/hour (students), R120/hour (business)",
    description: `Tutoring, consultations, and task help. TechnoSpeak takes a commission from completed tasks.`
    },
    {
    id: 6,
    title: "Plan 6 – Task Assistance - R1000/task (students), R1750/task (business)",
    description: `Hands-on help with tasks like coding or web development. Pay-per-task model.`
    }
];

// User current plan IDs
let userPlanIds = [1, 2];

function renderUserPlans() {
    const tableBody = document.getElementById("userPlans");
    tableBody.innerHTML = "";
    allPlans.forEach(plan => {
    if (userPlanIds.includes(plan.id)) {
        const row = document.createElement("tr");
        row.innerHTML = `
        <td>${plan.title}</td>
        <td>${plan.description}</td>
        <td><button onclick="unsubscribe(${plan.id})">Unsubscribe</button></td>
        `;
        tableBody.appendChild(row);
    }
    });
}

function renderOtherPlans() {
    const otherPlansDiv = document.getElementById("otherPlans");
    otherPlansDiv.innerHTML = "";
    allPlans.forEach(plan => {
    if (!userPlanIds.includes(plan.id)) {
        const card = document.createElement("div");
        card.className = "plan-card";
        card.innerHTML = `
        <h3>${plan.title}</h3>
        <p>${plan.description}</p>
        <button onclick="subscribe(${plan.id})">Register</button>
        `;
        otherPlansDiv.appendChild(card);
    }
    });
}

function unsubscribe(planId) {
    userPlanIds = userPlanIds.filter(id => id !== planId);
    renderUserPlans();
    renderOtherPlans();
}

function subscribe(planId) {
    if (!userPlanIds.includes(planId)) {
    userPlanIds.push(planId);
    renderUserPlans();
    renderOtherPlans();
    }
}

// Initial render plans
renderUserPlans();
renderOtherPlans();