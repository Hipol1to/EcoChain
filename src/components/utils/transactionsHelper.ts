import axios from "axios";
import {
  setGlobalString2,
  setGlobalString3,
  setGlobalString4,
  setGlobalString5,
  setGlobalString6,
} from "../utils/global";

export interface Transaction {
  sender: string;
  receiver: string;
  amount: number;
}

export const insertTransaction = async (transaction: Transaction) => {
  try {
    console.log("inseita");

    const response = await axios.post(
      "http://localhost/endpoint/insert_transaction.php",
      {
        type: "transaction",
        sender: transaction.sender,
        receiver: transaction.receiver,
        amount: transaction.amount,
      }
    );
    console.log("Transaction inserted", response);
  } catch (error) {
    console.error("Error inserting transaction", error);
  }
};

export const getRecipientWallet = async () => {
  try {
    const response = await axios.get(
      "http://localhost/endpoint/getRecipientWallet.php"
    );
    console.log("Recipient wallet:", response.data);
    setGlobalString2(response.data);
  } catch (error) {
    console.error("Error fetching wallet", error);
  }
};

export const getAmmountCollected = async () => {
  try {
    const response = await axios.get(
      "http://localhost/endpoint/getAmmountCollected.php"
    );
    console.log("ammount collected:", response.data);
    setGlobalString3(response.data);
  } catch (error) {
    console.error("Error fetching ammount collected", error);
  }
};

export const getEcoChainCurrentValue = async () => {
  try {
    const response = await axios.get(
      "http://localhost/endpoint/getCurrencyValue.php"
    );
    console.log("ecochain current value:", response.data);
    setGlobalString4(response.data);
  } catch (error) {
    console.error("Error fetching current value", error);
  }
};

export const getEcoChainReleaseValue = async () => {
  try {
    const response = await axios.get(
      "http://localhost/endpoint/getCurrencyReleaseValue.php"
    );
    console.log("ecochain release value:", response.data);
    setGlobalString5(response.data);
  } catch (error) {
    console.error("Error fetching release value", error);
  }
};

export const getInvestorsNumber = async () => {
  try {
    const response = await axios.get(
      "http://localhost/endpoint/getInvestorsNumber.php"
    );
    console.log("investors number:", response.data);
    setGlobalString6(response.data);
  } catch (error) {
    console.error("Error fetching investors number", error);
  }
};
