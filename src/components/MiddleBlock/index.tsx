import { useState } from "react";
import styled from "styled-components";
import { Row, Col } from "antd";
import { withTranslation, TFunction } from "react-i18next";
import { Slide } from "react-awesome-reveal";
import { Button } from "../../common/Button";
import { MiddleBlockSection, Content, ContentWrapper } from "./styles";
import {
  ContactContainer,
  FormGroup,
  Span,
} from "../../components/ContactForm/styles";
import Block from "../Block";
import { ethers } from "ethers";

// Modal Styled Components
const ModalOverlay = styled.div`
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
`;

const ModalContainer = styled.div`
  background-color: #fff;
  padding: 20px;
  width: 500px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  position: relative;
`;

const Title = styled.h1`
  text-align: center;
  margin-bottom: 10px;
`;

const Subtitle = styled.h3`
  text-align: center;
  color: #666;
  margin-bottom: 20px;
`;

const Input = styled.input`
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
`;

const SubmitButton = styled.button`
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #6200ea;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;

  &:hover {
    background-color: #3700b3;
  }
`;

const CloseButton = styled.button`
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;

  &:hover {
    color: red;
  }
`;

interface MiddleBlockProps {
  title: string;
  content: string;
  button: string;
  t: TFunction;
}

interface Window {
  ethereum?: {
    isMetaMask?: boolean;
    request: (...args: any[]) => Promise<any>;
  };
}

// MiddleBlock Component
const MiddleBlock = ({ title, content, button, t }: MiddleBlockProps) => {
  const [isOpen, setIsOpen] = useState(false);
  const [amount, setAmount] = useState("");
  const [recipient, setRecipient] = useState(""); // New recipient state
  const [status, setStatus] = useState(""); // Status message

  const defaultRecipient = "0x9c194a1dA7bAaF691a77176d56A1342a678B960B"; // Replace with your BSC address

  const openModal = () => setIsOpen(true);
  const closeModal = () => {
    // Reset form values and status
    setAmount(""); // Clear the amount field
    setStatus(""); // Clear the status message
    setIsOpen(false); // Close the modal
  };

  // MetaMask transaction handler
  const handleInvest = async (e) => {
    e.preventDefault();

    if (!window.ethereum) {
      setStatus("MetaMask is not installed!");
      return;
    }

    try {
      await window.ethereum.request({ method: "eth_requestAccounts" });
      const provider = new ethers.BrowserProvider(window.ethereum);
      const signer = provider.getSigner();

      const recipientAddress = defaultRecipient;

      const tx = {
        to: recipientAddress, // Binance address
        value: ethers.parseEther(amount), // Amount to be sent
        gasLimit: 21000,
        gasPrice: ethers.parseUnits("10", "gwei"),
      };

      const transaction = await (await signer).sendTransaction(tx);
      //setStatus("Transaction sent! Hash: " + transaction.hash);
      setStatus(
        "<img src='/img/loading.gif' style='max-width: 130px; height: 130px;'> <br> <p>Estamos procesando tu transacción.</p>, <br> <p>Por favor, espera.</p>"
      );

      await transaction.wait();
      setStatus(
        "<img src='/img/checked.png' style='max-width: 130px; height: 130px;'> <br><p>Transacción realizada.</p> <br> <p>Gracias por apoyar las finanzas sostenibles.</p>"
      );
    } catch (error) {
      console.error(error);
      let errorMessage = "";
      if (error instanceof Error) {
        errorMessage = error.message;
      }
      setStatus(
        "<img src='/img/failed.png' style='max-width: 130px; height: 130px;'> <br><p>Tu transacción no pudo ser realizada.</p> <br> <p>Por favor, inténtalo de nuevo.</p>"
      );
    }
  };

  return (
    <MiddleBlockSection>
      <Slide direction="up" triggerOnce>
        <Row justify="center" align="middle">
          <ContentWrapper>
            <Col lg={24} md={24} sm={24} xs={24}>
              <h6>{t(title)}</h6>
              <Content>{t(content)}</Content>
              {button && (
                <Button name="submit" onClick={openModal}>
                  {t(button)}
                </Button>
              )}
            </Col>
          </ContentWrapper>
        </Row>
      </Slide>

      {/* Modal */}
      {isOpen && (
        <ModalOverlay>
          <ModalContainer>
            <CloseButton onClick={closeModal}>×</CloseButton>
            <ContactContainer id={"invest-container"}>
              <Row justify="space-between" align="middle">
                <Slide direction="right" triggerOnce>
                  <FormGroup autoComplete="off" onSubmit={handleInvest}>
                    <Col span={24}>
                      <Block
                        title={"Apoya al futuro sostenible"}
                        content={
                          "Invierte en EcoChain y contribuye a las iniciativas globales de sostenibilidad con una tecnología segura y de vanguardia."
                        }
                      />
                      <Input
                        type="number"
                        name="Monto"
                        value={amount}
                        placeholder="Monto (BNB)"
                        onChange={(e) => setAmount(e.target.value)}
                        required
                      />
                      <SubmitButton type="submit">{t("Invertir")}</SubmitButton>
                      <br></br>
                      {/* Render status message with HTML */}
                      <div dangerouslySetInnerHTML={{ __html: status }}></div>
                    </Col>
                  </FormGroup>
                </Slide>
              </Row>
            </ContactContainer>
          </ModalContainer>
        </ModalOverlay>
      )}
    </MiddleBlockSection>
  );
};
export default withTranslation()(MiddleBlock);
