pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/your-username/your-repo.git'
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
                sshagent(['server-ssh-key']) {
                    sh """
                    ssh deploy@10.2.2.161 '
                        cd /opt/myapp &&
                        git pull origin main &&
                        docker compose up -d --build
                    '
                    """
                }
            }
        }
    }
}
