import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import { BrowserProvider, parseEther } from "ethers"; // Import BrowserProvider and parseEther

export function MetaMask() {
  const [amount, setAmount] = useState("");
  const [recipient, setRecipient] = useState(""); // Recipient address input
  const [status, setStatus] = useState("");

  // Hardcoded fallback recipient address
  const defaultRecipient = "0x9c194a1dA7bAaF691a77176d56A1342a678B960B"; // Replace with your BSC address

  // Function to send tokens using MetaMask
  const investTokens = async () => {
    if (!window.ethereum) {
      setStatus("MetaMask is not installed!");
      return;
    }

    try {
      // Request MetaMask to connect to the user's wallet
      await window.ethereum.request({ method: "eth_requestAccounts" });

      // Create provider and signer from MetaMask
      const provider = new BrowserProvider(window.ethereum); // Use BrowserProvider in v6
      const signer = await provider.getSigner();

      // Use either the user-input address or the default one
      const recipientAddress = recipient || defaultRecipient;

      // Transaction details
      const tx = {
        to: recipientAddress, // Use recipient or default address
        value: parseEther(amount), // Convert amount to wei (BNB)
        gasLimit: 21000, // Gas limit for sending BNB
        gasPrice: parseEther("0.00000001"), // Optional gas price, you can adjust this
      };

      // Send transaction
      const transaction = await signer.sendTransaction(tx);
      setStatus("Transaction sent! Hash: " + transaction.hash);

      // Wait for transaction to be mined
      await transaction.wait();
      setStatus("Transaction confirmed!");
    } catch (error) {
      console.error(error);
      setStatus("Transaction failed: " + error.message);
    }
  };
}

module.exports = MetaMask;
