import pandas as pd
from sklearn.decomposition import TruncatedSVD
import numpy as np
import json

# 1️⃣ Load data
orders = pd.read_json('/Applications/laravel/ai-tool/storage/orders.json')
products = pd.read_json('/Applications/laravel/ai-tool/storage/products.json')

# 2️⃣ Create user-product matrix
matrix = orders.pivot_table(index='user_id', columns='product_id', values='quantity', fill_value=0)

# 3️⃣ Train SVD
svd = TruncatedSVD(n_components=20)
matrix_svd = svd.fit_transform(matrix)

# 4️⃣ Generate recommendations
recommendations = {}
for idx, user_id in enumerate(matrix.index):
    approx = np.dot(matrix_svd[idx], svd.components_)
    purchased_idx = np.nonzero(matrix.iloc[idx] > 0)[0]  # SonarQube compliant
    recommended_idx = [i for i in approx.argsort()[::-1] if i not in purchased_idx][:10]
    recommendations[user_id] = matrix.columns[recommended_idx].tolist()

# 5️⃣ Save recommendations
with open('/Applications/laravel/ai-tool/storage/recommendations.json', 'w') as f:
    json.dump(recommendations, f, indent=4)

print("Recommendations generated successfully!")
