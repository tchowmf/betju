<form id="betForm">
    <h3>Faça sua Aposta</h3>
    <label for="betType">Tipo de Aposta:</label>
    <select id="betType" name="bet_type">
        <option value="winner">Vencedor</option>
        <option value="games">Games do Perdedor</option>
    </select>
    <br>
    <label for="betValue">Valor da Aposta:</label>
    <input type="number" id="betValue" name="bet_value" min="1">
    <br>
    <button type="button" onclick="submitBet()">Apostar</button>
</form>

<script>
function submitBet() {
    const betForm = document.getElementById('betForm');
    const betType = betForm.bet_type.value;
    const betValue = parseInt(betForm.bet_value.value, 10);
    const betAmount = 15;

    if (betValue <= 0) {
        alert('Valor da aposta deve ser positivo.');
        return;
    }

    // Validação de créditos do usuário
    fetch('/api/user/credits')
        .then(response => response.json())
        .then(data => {
            const userCredits = data.credits;
            const totalBetAmount = betAmount * betValue;

            if (userCredits < totalBetAmount) {
                alert('Créditos insuficientes.');
                return;
            }

            // Submeter a aposta
            fetch('/api/bets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ bet_type: betType, bet_value: betValue, bet_amount: totalBetAmount }),
            })
            .then(response => response.json())
            .then(data => {
                alert('Aposta realizada com sucesso!');
                // Atualizar créditos do usuário
                // ...
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        });
}
</script>
