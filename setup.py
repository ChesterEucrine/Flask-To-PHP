import os

# uncomment to set password
#change_password("password goes here")

print("Installing dependencies...")
print(" Running: pip3 install -r requirements.txt")
os.system("pip3 install -r requirements.txt")


from passlib.hash import sha256_crypt

PASSWORD_FILE = './PASSWORD_HASH_DO_NOT_COMMIT'

def change_password(newPassword):
    with open(PASSWORD_FILE, 'w') as f:
        f.write(sha256_crypt.hash(newPassword))

print("Enter the advisor password:")
password = input()

change_password(password)

print(f"Password changed to '{password}'. Advisor view (keep secret - do not share with students) available at https://ecsadvising.utdallas.edu/degreeaudit/#{password}")
print(f"Student view accessible at https://ecsadvising.utdallas.edu/degreeaudit/")

print("")

print("The flask application can serve the React application -- make sure to do `yarn build` first")
print("(`yarn start` can still be used for development builds")
