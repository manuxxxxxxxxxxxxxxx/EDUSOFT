"""
**************************************************************
Proyecto : Atenea (Versión mínima)
Archivo  : app.py
Secuencia: 01
Descripción:
    Archivo principal de Flask para el chat con Gemini.
    - Recibe mensajes desde chat.html
    - Envía a Gemini y retorna respuestas
    - Permite limpiar el historial de mensajes
    - Ajustado para formato de investigación con comillas
**************************************************************
"""

from flask import Flask, render_template, request, redirect, url_for
import google.generativeai as genai

app = Flask(__name__)

# ====================================================
# CONFIGURACIÓN DE LA API KEY DE GEMINI
# ====================================================
# OPCIÓN 2 (temporal para pruebas): colocar la API Key aquí
GEMINI_API_KEY = "AIzaSyBdOunBZQGGxwTsgaOAjZ73RpZbTo_JZKk"   # <<< Coloca tu API Key aquí

# Configurar el SDK de Gemini
genai.configure(api_key=GEMINI_API_KEY)
model = genai.GenerativeModel("gemini-1.5-flash")

# Mensajes temporales en memoria (no persiste)
messages = []

@app.route("/", methods=["GET", "POST"])
def chat_page():
    """
    Ruta principal del chat.
    - GET: muestra la página de chat con mensaje inicial
    - POST: recibe mensaje del usuario, envía a Gemini y devuelve respuesta
    """
    global messages

    # Mensaje inicial de bienvenida
    if not messages:
        messages.append(("atenea", "Hola, soy Atenea, tu guía para investigaciones. "
                                   "Escríbeme un tema y te daré un formato sugerido. "
                                   "Solo puedo ayudar con el formato de la investigación, no desarrollarla por ti. "
                                   "No puedo responder temas ilegales, no éticos o fuera de investigación."))

    if request.method == "POST":
        user_message = request.form.get("user_input", "").strip()
        if user_message:
            messages.append(("user", user_message))

            # Prompt para Gemini: esquema de investigación con comillas
            prompt = f"""
Eres Atenea, una guía académica que ayuda a los alumnos a aprender a investigar.
Siempre inicia con un saludo: "Hola, soy Atenea".

INSTRUCCIONES:
- Devuelve la respuesta solo en formato de esquema, listo para copiar y pegar.
- Usa encabezados numerados (1. Introducción, 2. Marco Teórico, etc.).
- Usa corchetes [ ] para que el alumno complete datos.
- Incluye todas las secciones principales: Título, Autor, Fecha, Resumen, Introducción, Marco Teórico, Metodología, Resultados, Discusión, Conclusiones, Bibliografía, Anexos (opcional).
- Sugiere un formato alternativo si el tema lo amerita.
- Si el alumno pide un tema inapropiado o no académico, responde con: "Lo siento, no puedo ayudarte con ese tema. Por favor, elige otro."
- El alumno preguntará sobre un item o sección de la investigacion, explicale brevemente en que consiste y su importancia.
- Para enfatizar palabras clave, usa mayúsculas o negritas (si es posible).
- No desarrolles el contenido, solo el formato.
- Para enfatizar palabras clave o parrafos usa comillas dobles " ", no asteriscos.

Pregunta del alumno: {user_message}
"""

            try:
                response = model.generate_content(prompt)
                atenea_response = response.text
            except Exception as e:
                atenea_response = f"❌ Error al comunicarse con Gemini: {e}"

            messages.append(("atenea", atenea_response))

    return render_template("chat.html", messages=messages)

@app.route("/clear", methods=["POST"])
def clear_messages():
    """
    Limpia el historial de mensajes en memoria
    """
    global messages
    messages = []
    return redirect(url_for('chat_page'))

if __name__ == "__main__":
    app.run(debug=True)
