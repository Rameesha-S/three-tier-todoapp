pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/Rameesha-S/three-tier-todoapp.git',
                    credentialsId: 'github-token'
            }
        }

        stage('Build') {
            steps {
                echo "Building application..."
            }
        }

        stage('Test') {
            steps {
                echo "Running tests..."
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                    if [ ! -d /opt/myapp/.git ]; then
                        git clone https://github.com/Rameesha-S/three-tier-todoapp.git /opt/myapp
                    fi
                    cd /opt/myapp
                    git pull origin main
                    docker compose up -d --build
                '''
            }
        }
    }
}
