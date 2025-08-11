<div class="modal" id="premiumSubscriptionModal" onclick="closeModal(event, 'premiumSubscriptionModal')">
    <div class="card popup-content" onclick="event.stopPropagation();">
        <div class="plan_title">
            <h2>Premium Subscription Required</h2>
        </div>
        <div class="icon">
            <img src="@secureAsset('/images/icons/premium.png')" alt="Premium Subscription"/>
        </div>
        <div class="price">
            <p>
                <span><sup class="context">R</sup></span>
                350
                <span class="dur">/ quarterly</span>
            </p>
        </div>
        <div class="dscpt_container">
            <div class="dscpt">
                <div class="tick"><img src="@secureAsset('/images/icons/quality.png')"/></div>
                <div class="dscpt-p"><p>Unlock all premium trainings</p></div>
            </div>
            <div class="dscpt">
                <div class="tick"><img src="@secureAsset('/images/icons/quality.png')"/></div>
                <div class="dscpt-p"><p>Downloadable resources</p></div>
            </div>
            <div class="dscpt">
                <div class="tick"><img src="@secureAsset('/images/icons/quality.png')"/></div>
                <div class="dscpt-p"><p>Monthly tech newsletters</p></div>
            </div>
            <div class="dscpt">
                <div class="tick"><img src="@secureAsset('/images/icons/quality.png')"/></div>
                <div class="dscpt-p"><p>Cheatsheets & guides</p></div>
            </div>
        </div>
        <div class="bttn">
            <a href="{{ route('stripe.checkout', ['clientId' => auth()->id(), 'planId' => 'subscription_6']) }}" 
               class="btn btn-primary">
                SUBSCRIBE NOW
            </a>
            <button class="btn btn-secondary" onclick="document.getElementById('premiumSubscriptionModal').style.display='none'">
                NOT NOW
            </button>
        </div>
    </div>
</div>