pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/Rameesha-S/three-tier-todoapp.git'
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
                // Run commands directly on the Jenkins server (10.2.2.161)
                sh '''
                    cd /opt/myapp
                    git pull origin main
                    docker compose up -d --build
                '''
            }
        }
    }
}
