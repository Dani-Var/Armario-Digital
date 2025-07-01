
from flask import Flask, render_template, request, redirect, url_for, flash, session
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///closet_fashion.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SECRET_KEY'] = 'closet_fashion_secret_key'
db = SQLAlchemy(app)

class Cliente(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nome = db.Column(db.String(100), nullable=False)
    cpf = db.Column(db.String(14), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    senha = db.Column(db.String(120), nullable=False)

    def __repr__(self):
        return f'<Cliente {self.nome}>'

class Empresa(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nome_loja = db.Column(db.String(100), nullable=False)
    cnpj = db.Column(db.String(18), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    senha = db.Column(db.String(120), nullable=False)

    def __repr__(self):
        return f'<Empresa {self.nome_loja}>'

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/login', methods=['POST'])
def login():
    tipo_usuario = request.form.get('tipo_usuario')
    documento = request.form.get('documento')
    senha = request.form.get('senha')
    
    if tipo_usuario == 'cliente':
        cliente = Cliente.query.filter_by(cpf=documento, senha=senha).first()
        if cliente:
            session['user_id'] = cliente.id
            session['user_type'] = 'cliente'
            return redirect(url_for('pagina_cliente'))
        else:
            flash('CPF ou senha incorretos')
    elif tipo_usuario == 'empresa':
        empresa = Empresa.query.filter_by(cnpj=documento, senha=senha).first()
        if empresa:
            session['user_id'] = empresa.id
            session['user_type'] = 'empresa'
            return redirect(url_for('pagina_empresa'))
        else:
            flash('CNPJ ou senha incorretos')
    
    return redirect(url_for('index'))

@app.route('/cadastro_cliente', methods=['GET', 'POST'])
def cadastro_cliente():
    if request.method == 'POST':
        nome = request.form['nome']
        cpf = request.form['cpf']
        email = request.form['email']
        senha = request.form['senha']
        confirmar_senha = request.form['confirmar_senha']
        
        if senha != confirmar_senha:
            flash('As senhas não coincidem')
            return render_template('cadastro_cliente.html')
        
        # Verificar se CPF ou email já existem
        cliente_existente = Cliente.query.filter((Cliente.cpf == cpf) | (Cliente.email == email)).first()
        if cliente_existente:
            flash('CPF ou email já cadastrados')
            return render_template('cadastro_cliente.html')
        
        novo_cliente = Cliente(nome=nome, cpf=cpf, email=email, senha=senha)
        db.session.add(novo_cliente)
        db.session.commit()
        flash('Cliente cadastrado com sucesso!')
        return redirect(url_for('index'))
    return render_template('cadastro_cliente.html')

@app.route('/cadastro_empresa', methods=['GET', 'POST'])
def cadastro_empresa():
    if request.method == 'POST':
        nome_loja = request.form['nome_loja']
        cnpj = request.form['cnpj']
        email = request.form['email']
        senha = request.form['senha']
        confirmar_senha = request.form['confirmar_senha']
        
        if senha != confirmar_senha:
            flash('As senhas não coincidem')
            return render_template('cadastro_empresa.html')
        
        # Verificar se CNPJ ou email já existem
        empresa_existente = Empresa.query.filter((Empresa.cnpj == cnpj) | (Empresa.email == email)).first()
        if empresa_existente:
            flash('CNPJ ou email já cadastrados')
            return render_template('cadastro_empresa.html')
        
        nova_empresa = Empresa(nome_loja=nome_loja, cnpj=cnpj, email=email, senha=senha)
        db.session.add(nova_empresa)
        db.session.commit()
        flash('Empresa cadastrada com sucesso!')
        return redirect(url_for('index'))
    return render_template('cadastro_empresa.html')

@app.route('/esqueceu_senha')
def esqueceu_senha():
    return render_template('esqueceu_senha.html')

@app.route('/pagina_cliente')
def pagina_cliente():
    if 'user_id' not in session or session.get('user_type') != 'cliente':
        return redirect(url_for('index'))
    
    cliente = Cliente.query.get(session['user_id'])
    return render_template('pagina_cliente.html', cliente=cliente)

@app.route('/pagina_empresa')
def pagina_empresa():
    if 'user_id' not in session or session.get('user_type') != 'empresa':
        return redirect(url_for('index'))
    
    empresa = Empresa.query.get(session['user_id'])
    return render_template('pagina_empresa.html', empresa=empresa)

@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('index'))

if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True, host='0.0.0.0')


