#!/bin/bash
# Script to install dompdf library for Joomla

echo "Installing dompdf library..."

# Create the directory structure
mkdir -p libraries/techjoomla/dompdf

# Download dompdf
cd libraries/techjoomla/dompdf
wget https://github.com/dompdf/dompdf/releases/download/v2.0.3/dompdf-2.0.3.zip

# Extract
unzip dompdf-2.0.3.zip

# Move files to current directory
mv dompdf-2.0.3/* .
mv dompdf-2.0.3/.* . 2>/dev/null || true

# Clean up
rm -rf dompdf-2.0.3 dompdf-2.0.3.zip

echo "Dompdf installed successfully!"
echo "Location: libraries/techjoomla/dompdf/"
