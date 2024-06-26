const stripe        = stripe_config;
const elements      = stripe.elements()
const cardElement   = elements.create('card')

cardElement.mount('#card-element')

const form = document.getElementById('payment-form')
const cardButton = document.getElementById('card-button')
const cardHolderName = document.getElementById('card-holder-name')

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    cardButton.disabled = true;

    const { setupIntent, error } = await stripe.confirmCardSetup(
        cardButton.dataset.secret, {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: cardHolderName.value
                }
            }
        }
    )

    if(error) {
        cardButton.disabled = false
    } else {
        let token = document.createElement('input')

        token.setAttribute('type', 'hidden')
        token.setAttribute('name', 'token')
        token.setAttribute('value', setupIntent.payment_method)

        form.appendChild(token)
        form.submit()
    }
})