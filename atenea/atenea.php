
<!DOCTYPE html>
<html>
<head>
    <title>Atenea</title>
</head>
<body>
    <h1>Chat con Atenea</h1>
    <form method="post">
        <input type="text" name="user_input" placeholder="Escribe tu mensaje" required>
        <button type="submit">Enviar</button>
    </form>

    <div>
        {% for sender, text in messages %}
            <p><b>{{ sender }}:</b> {{ text }}</p>
        {% endfor %}
    </div>

    <form method="post" action="{{ url_for('clear_messages') }}">
        <button type="submit">Limpiar historial</button>
    </form>
</body>
</html>